# Registration-Sys-PHP / registration-nervtheme-PHP

### Hosted using Render. Do **NOT** copy this UI to the last pixel.
### Only a practical application from the tutorial video provided eariler:
https://youtu.be/WaRhPMrH3AY?si=pUsAAzlqqwQTaFeo

# Sections
## [Vulnerability Note](#vulnerability-note-1)
## [How to Change Directories for Anchor Tags, Headers and Forms](#how-to-change-directories-for-anchor-tags-headers-and-forms-1)
  - [Headers](#headers)
  - [Anchor Tags](#anchor-tags)
  - [Forms](#forms)
## [Hosting with Render](#hosting-with-render-1)
  - [Creating your Dockerfile](#creating-your-dockerfile)
## [FreeDB Hosting for SQL](#freedb-hosting-for-sql-1)
## [Images](#images)






# Vulnerability Note:
## Remove this part of code within login.php
```php

        $entered = 'TestPass444';
        $hash = '$2y$10$YHlni1Ev/XuE0H6TVCWiq.bL/nn1l7brL5sxCP2HYZZE3Re61FJ12';
        
        if (password_verify($entered, $hash)) {
            echo "✅ Password matches!";
        } else {
            echo "❌ Still doesn't match.";
        }
```
and
```php
 echo "<script>
console.log('Entered: " . $_POST['pass-auth'] . "');
console.log('Stored: " . $stored_password . "');
console.log('Match: " . (password_verify($_POST['pass-auth'], $stored_password) ? 'yes' : 'no') . "');
</script>";
```
This is for debugging.



# How to change directories for anchor tags, headers and forms

## Headers: 
```php
header("Location: home.php");
```
> in this instance, if your redirection target is a php in the same folder, you can try
```php
Location: ./home.php //or your php of choice
```
> or;
```php
Location: https://aws.amazon.com/free/webapps/?trk=80c137f7-7e39-4c7a-b481-96610db15b91&sc_channel=ps&ef_id=CjwKCAjwwqfABhBcEiwAZJjC3uaRoON40S35jxwgQkElW0sswS_opUHTulJP77wKxDH2hqkVoXDhdxoCBnAQAvD_BwE:G:s&s_kwcid=AL!4422!3!637478417987!p!!g!!php%20hosting!19043613097!147457550801&gclid=CjwKCAjwwqfABhBcEiwAZJjC3uaRoON40S35jxwgQkElW0sswS_opUHTulJP77wKxDH2hqkVoXDhdxoCBnAQAvD_BwE
```
- Make sure that this is within " ".

## anchor tags:
> Here is an example of a button that redirects using an anchor tag.
```html
 <a href="./login.php">
      <button type="button">Log In</button>
</a> 
```
> How should we change this?
```html
./filename.html(or .php, or .js)
```
> What is `./`?
 - ./ basically means "relative path" for the current location where index.html or index.php is.

> For Example

> In this File Structure:
```
->htdocs
  ->eldtrich
    ->index.html
    ->home.html
```
> Notice how home.html is in the same file path? We can use `./home.html` to point to this file.
> However, if in the case where:
```
->htdocs
  ->eldtrich
      ->tools
         ->db.php
      ->home
         ->home.html
    ->index.html
```
> home.html is in a different location. we can then assume that `./` means "root"
> Therefore; `./home/home.html` means the same as `C:\Users\ADMIN\YourFolderHere\home\home.html`

# Forms:
> If you are also using Javascript, please make sure that you either remove them or make sure you have code for them.
> For 
```html
<button type="button">
```
> make sure that you remove any `onclick=""` instance.


# Hosting with Render

## To begin hosting with Render, we must first make an account [here](https://dashboard.render.com/login)
> Once logged in, we must create a new web service.
![image](https://github.com/user-attachments/assets/eb13aa0e-b13c-465a-a06e-ce494fabdf0d)

> Afterwards, you must connect your github account to render.
> Upload your code to a Github Repository. After this, Render will ask you for a repository to connect:
![image](https://github.com/user-attachments/assets/a9f6921c-2950-4667-84e5-91c9e428038b)

> Fill up your project's information form.
![image](https://github.com/user-attachments/assets/a17d55d4-fc84-41d4-b77b-9eb4614cde87)

> It is important that you select "Free"
![image](https://github.com/user-attachments/assets/7a6d8f4f-3a14-482e-a32a-5a0c8e3a92e3)

> Deploy your web service.
![image](https://github.com/user-attachments/assets/1cf83e75-e866-49c9-8c26-1d303e8f26fe)

## Creating your Dockerfile:

> You must create a new file in your repository.
![image](https://github.com/user-attachments/assets/3a41325b-be13-4522-b6ca-f85105773b92)

> Name it "Dockerfile"
![image](https://github.com/user-attachments/assets/136f2f7c-910b-4d88-a65f-1c18a54fbaef)

> and copy the following code.

```go
FROM php:8.2-fpm-alpine

# Install NGINX, Git, Bash, MariaDB dev (needed for mysqli), and Supervisor
RUN apk add --no-cache \
    nginx \
    git \
    bash \
    mariadb-dev \
    supervisor \
    && docker-php-ext-install mysqli

# Create required directories
RUN mkdir -p /run/nginx

# Set working directory
WORKDIR /app

# Copy your application code
COPY . .

# Copy NGINX config
COPY nginx.conf /etc/nginx/nginx.conf

# Copy supervisord config
COPY supervisord.conf /etc/supervisord.conf

# Expose the port Render will listen to
EXPOSE 10000

# Start Supervisor (manages both PHP-FPM and NGINX)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
```
> Do the same for `nginx.conf` and `supervisord.conf`:

> ### nginx.conf
```
worker_processes 1;

events {
  worker_connections 1024;
}

http {
  include       mime.types;
  default_type  application/octet-stream;

  sendfile        on;

  server {
    listen       10000;
    server_name  localhost;

    root /app;  # <--- point to the root directory
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        include        fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
  }
}
```
> ### supervisord.conf
```
[supervisord]
nodaemon=true

[program:php-fpm]
command=php-fpm

[program:nginx]
command=nginx -g 'daemon off;'
```

> ## Finally, Render Hosting is done!



# FreeDB hosting for SQL

## Make an account [here](https://freedb.tech/register.html)
> After your registration, create your database here. 

![image](https://github.com/user-attachments/assets/ac310443-be24-45bb-8c73-0cb9bb0e488e)


> Please take not that this will not take "root" or "sroot" as a user.



> Take these into consideration:

![image](https://github.com/user-attachments/assets/569dbf25-6150-46ca-aa51-66c4555ddfbb)

> Save your HOST, your USER, and your PASSWORD. Once you're ready, you can click the barrel next to the password field.
> You will be taken to freedb's phpMyAdmin, use your credentials to access your database.
![image](https://github.com/user-attachments/assets/67108cfc-c580-42f2-8526-028ce1362383)

> Once in phpMyAdmin, you can once again create your table in your database.

```SQL
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(200) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'client',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```
> once the table is done, head back to your `db.php`
> change these values:
```php
$servername = "sql.freedb.tech";
    $username = "freedb_yourusername";
    $password = "yourpassword";
    $database = "freedb_yourdatabase";
    $port = 3306;
```
> into the values you got from FreeDB.tech.


## After this, return to your Render Dashboard, click Manual Deploy > Deploy Latest Commit
> Once the build is done, click the link and look at your website.




# Images:

### Registration:
![image](https://github.com/user-attachments/assets/243351c0-54dc-48ee-b249-7ba562c8b7dd)

### Login:
![image](https://github.com/user-attachments/assets/2600f42f-2702-4bc5-be0a-4fda181e06fd)

### Control Panel:
![image](https://github.com/user-attachments/assets/3023e633-3b07-49eb-9c40-0f34b34b25d1)
