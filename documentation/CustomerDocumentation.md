# Kunden Dokumentation / Customer Documentation

## Deutsch

Ihnen stehen die drei Dokumentationen: IT-Administrator, Teacher und Student zur Verfügung,
in denen alles Wichtige für die jeweiligen Positionen steht. Diese drei Dokumentationen können
Sie den jeweiligen Personen zur Verfügung stellen.

### Informationen für den Server

Es gibt zwei Fälle:

1.  Sie hosten ein JupyterHub-Server für die Schulen.\
    Informationen wie man einen Server aufsetzt, finden Sie in der
    IT-AdminDocumentation.\
    In dem Fall müssen Sie die URL Ihres Moodle Servers sowie
    das jeweils spezifische Secret den Schulen mitliefern.

2.  In dem Fall setzen die Schulen ihren eigenen Server auf.\
    Hierfür brauchen die Schulen die `jupyterhub_docker.zip` file, damit
    diese alles Nötige haben.

### Informationen für das Plugin

Für das Plugin ist es egal welche der beiden Optionen Sie oben gewählt haben,
denn in beiden Fällen müssen Sie die `Jupyter.zip` Datei mitliefern.\
Der andere wichtige Part für das Plugin ist die Git Repository URL, der Branch sowie das zu
öffnende Notebook.\
Diese Infos sind relevant für die Lehrer und Lehrerinnen.

## English

The three documentations are available to you: IT Administrator, Teacher and Student,
in which everything important for the respective positions can be found. You can provide these
three documentations to the respective persons.

### Information for the server

There are two cases:

1. you are hosting a JupyterHub server for the schools.\
   Information on how to set up a server can be found in the
   IT-AdminDocumentation.\
   In this case you have to provide the URL of your Moodle server as well as
   the specific secret to the schools.

2. in that case the schools set up their own server.\
   For this the schools need the `jupyterhub_docker.zip` file, so that
   they have everything they need.

### Information for the plugin

For the plugin it doesn't matter which of the two options you have chosen above,
because in both cases you have to include the `jupyter.zip` file.\
The other important part for the plugin is the Git repository URL, the branch as well as the
notebook to open.\
This info is relevant for the schools.
