# Use PHP 8.0 with Apache
FROM php:8.0-apache

# Enable URL rewriting
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy all your files inside container
COPY . /var/www/html/

# Expose Apache default port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
