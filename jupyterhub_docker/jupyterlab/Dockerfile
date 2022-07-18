FROM jupyter/minimal-notebook:2022-07-06

COPY ./jupyter_notebook_config.py /etc/jupyter/

#RUN echo "c.NotebookApp.tornado_settings = {'cookie_options': {\"SameSite\": \"None\", \"Secure\": True}, 'headers': { 'Content-Security-Policy': \"frame-ancestors 'self' http://localhost:80 http://127.0.0.1:80 http://localhost:8000 http://127.0.0.1:8000\"}}" >> /etc/jupyter/jupyter_notebook_config.py
#RUN echo 'c.NotebookApp.disable_check_xsrf = True' >> /etc/jupyter/jupyter_notebook_config.py

