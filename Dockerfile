FROM arubinst/sti:project2018

RUN echo >> /etc/php5/fpm/php.ini
RUN echo error_reporting = E_ALL >> /etc/php5/fpm/php.ini
RUN echo display_errors = on >> /etc/php5/fpm/php.ini
