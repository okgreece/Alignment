#Alignment 

Ontology matching is a crucial problem in the world of Semantic Web and other distributed, open world applications. Diversity in tools, knowledge, habits, language, interests and usually level of detail may drive in heterogeneity. Thus, many automated applications have been developed, implementing a large variety of matching techniques and similarity measures, with impressive results. 

However, there are situations where this is not enough and there must be human decision in order to create a link. We present Alignment, a collaborative, system aided, user driven ontology matching application. Alignment offers a simple GUI environment for matching two ontologies/vocubularies with aid of configurable similarity algorithms. We undertake research for the evaluation and validation of the default settings, taking into account expert users feedback. 

Multiple users can work on the same project simultaneously. The application offers also social features, as users can vote, providing feedback, on the produced linksets. The linksets are available through a SPARQL endpoint and an API. 

Alignment is the outcome of the experience working with heterogeneous public budget data, and has been used to align SKOS Vocabularies describing budget data across diverse level of administrations of the EU and it’s member states.

#Requirements
* Composer
* PHP(5.4.*)
* PHP capable web server
* MySQL
* Java 8

#Installation steps

```bash
#clone the repo
git clone https://github.com/okgreece/Alignment.git

#run composer
composer install

#create an .env file from .env.example
cp .env.example .env

#change your database credentials using your favorite text editor

#run the migrations
php artisan migrate

#seed the database
php artisan db:seed

#run the Job Que. Change www-data accordingly, to reflect your server user name.
sudo -u www-data php artisan queue:listen --timeout=600 --sleep=30 --tries=5

# in case you hit on 500 errors, try changing permissions. Your web server should 
# have write permissions on public and storage folders at least.
```

#Import Silk Configuration
You can now import your own Silk configuration to be used by Silk engine. Just go to Settings panel and create a new Setting. You will be prompt to
give a friendly name and upload a Silk LSL configuration file. Uploaded file will be validated using libxml library and the appropriate schema.
If the file is validated correctly it will be shown on your project configuration to choose. Then calculate the similarities using your newly updated Silk LSL.

