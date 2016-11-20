#Alignment 

Ontology matching is a crucial problem in the world of Semantic Web and other distributed, open world applications. Diversity in tools, knowledge, habits, language, interests and usually level of detail may drive in heterogeneity. Thus, many automated applications have been developed, implementing a large variety of matching techniques and similarity measures, with impressive results. 

However, there are situations where this is not enough and there must be human decision in order to create a link. In this paper we present Alignment, a collaborative, system aided, user driven ontology matching application. Alignment offers a simple GUI environment for matching two ontologies/vocubularies with aid of configurable similarity algorithms. We undertake research for the evaluation and validation of the default settings, taking into account expert users feedback. 

Multiple users can work on the same project simultaneously. The application offers also social features, as users can vote, providing feedback, on the produced linksets. The linksets are available through a SPARQL endpoint and an API. 

Alignment is the outcome of the experience working with heterogeneous public budget data, and has been used to align SKOS Vocabularies describing budget data across diverse level of administrations of the EU and it’s member states.

#Requirements
* Composer
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

#run the Job Que
sudo -u www-data php artisan queue:listen --timeout=600 --sleep=30
```
