FROM php:8.2-fpm-alpine

# Install NGINX and other dependencies
RUN apk add --no-cache nginx git bash

# Create required directories
RUN mkdir -p /run/nginx

# Set working directory
WORKDIR /app

# Copy your code
COPY . .

# Copy NGINX config
COPY nginx.conf /etc/nginx/nginx.conf

# Expose the port Render will listen to
EXPOSE 10000

# Use supervisord to run both nginx and php-fpm
RUN apk add --no-cache supervisor
COPY supervisord.conf /etc/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
