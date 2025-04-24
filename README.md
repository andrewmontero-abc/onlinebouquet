# Registration-Sys-PHP

### Localhosted using XAMPP, with Apache and MySQL. Use PHP code wisely, do **NOT** copy this UI to the last pixel.
### Only a practical application from the tutorial video provided eariler: https://youtu.be/WaRhPMrH3AY?si=pUsAAzlqqwQTaFeo

# Vulnerability Note: Remove this part of code within login.php
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

In this File Structure:
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


 
# Images:

### Registration:
![image](https://github.com/user-attachments/assets/243351c0-54dc-48ee-b249-7ba562c8b7dd)

### Login:
![image](https://github.com/user-attachments/assets/2600f42f-2702-4bc5-be0a-4fda181e06fd)

### Control Panel:
![image](https://github.com/user-attachments/assets/3023e633-3b07-49eb-9c40-0f34b34b25d1)
