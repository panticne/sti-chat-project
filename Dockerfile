FROM arubinst/sti:project2018

# Pour que les erreurs et warnings PHP soient affichés.
RUN echo >> /etc/php5/fpm/php.ini
RUN echo error_reporting = E_ALL >> /etc/php5/fpm/php.ini
RUN echo display_errors = on >> /etc/php5/fpm/php.ini
