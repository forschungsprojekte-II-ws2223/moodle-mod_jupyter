FROM jupyterhub/jupyterhub:2.3.0

COPY ./jupyterhub_config.py .

#we dont need this, more recent verison available in pip
#RUN wget https://raw.githubusercontent.com/jupyterhub/jupyterhub/0.9.3/examples/cull-idle/cull_idle_servers.py

RUN pip install --no-cache-dir \
    dockerspawner==12.1.0 \
    jupyterhub-idle-culler==1.2.1 \
    psycopg2-binary==2.9.3 \