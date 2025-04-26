# Use the official PHP image from Docker Hub
FROM php:8.0-apache

# Enable mod_rewrite (needed for some PHP frameworks)
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your code into the container
COPY . /var/www/html/

# Expose port 80 to the outside world
EXPOSE 80

# Set the entry point for the container to Apache
CMD ["apache2-foreground"]
