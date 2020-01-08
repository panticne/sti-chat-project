FROM arubinst/sti:project2018

RUN echo >> /etc/php5/fpm/php.ini

# Ajuste le fuseau horaire
RUN echo date.timezone = Europe/Zurich >> /etc/php5/fpm/php.ini

# Pour que les erreurs et warnings PHP soient affichés.
# À enlever lorsque l'application tourne en production.
RUN echo error_reporting = E_ALL >> /etc/php5/fpm/php.ini
RUN echo display_errors = on >> /etc/php5/fpm/php.ini
