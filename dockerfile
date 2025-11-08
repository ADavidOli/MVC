# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos extensiones comunes de PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activamos mod_rewrite (para URLs limpias tipo /perfil/index)
RUN a2enmod rewrite

# Copiamos el contenido del proyecto al contenedor
COPY . /var/www/html

# Cambiamos el DocumentRoot para apuntar a public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Definimos el directorio de trabajo
WORKDIR /var/www/html

# Exponemos el puerto 80 del contenedor
EXPOSE 80
