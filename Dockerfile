FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install dependencies
RUN apk add --update --no-cache  \
    git  \
    && rm -rf /var/cache/apk/*

# Expose port
EXPOSE 9000

# Set environment variables
ENV ALLOW_HOST_REACHABLE=1

# Set webserver user
RUN adduser -D webuser

# Run PHP-FPM
USER webuser
CMD ["php-fpm"]
