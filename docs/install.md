## Development Environment Installation

This package use composr, laravel/homestead and vagrant to facilitate local development. So before starting make sure you have the following installed:

- [Composer](https://getcomposer.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Virtualbox](https://www.virtualbox.org/wiki/Downloads)

### Setup

First, we clone the github repository to our local machine. Next, from the repo route directory we run composer to install all the dependent packages. Finally, we run vagrant up which will set up a local virtual machine.

```bash
git clone git@github.com:ushahidi/comrades-service-proxy.git
cd comrades-service-proxy
composer install
vagrant up
```

#### Environment configuration

Copy the environment configuration.

```bash
cp .env.example .env
```

Edit the .env file and set the appropriate values for the following entries:

```

SHARED_SECRET=<your_platform_comrades_shared_secret_at_least_20_chars>
USHAHIDI_PLATFORM_API_URL=<full_url_of_ushahidi_platform_instance>
USHAHIDI_PLATFORM_SOURCE_SURVEY_FIELD_NAME=<name_of_source_field_on_platform_survey_that_should_be_annotated>
USHAHIDI_PLATFORM_DESTINATION_SURVEY_FIELD_NAME=<name_of_destination_field_on_platform_survey_where_annotation_should_be_saved>

YODIE_API_URL=<full_url_of_yodie_api>
YODIE_API_KEY=<yodie_api_key>
YODIE_API_SECRET=<yodie_api_secret>
YODIE_QUOTA=<remaining quota>
YODIE_REQUEST_COST=<cost per request>
YODIE_QUOTA_RESET=<reset delay>

CREES_API_URL="<full_url_of_crees_api>"

CREES_EVENT_RELATED="eventRelated"
CREES_EVENT_TYPE="eventType"
CREES_INFO_TYPE="infoType"


ACTIONABILITY_API_URL=<full_url_of_actionability_api>
ACTIONABILITY_QUOTA=<remaining quota>
ACTIONABILITY_REQUEST_COST=<cost per request>
ACTIONABILITY_QUOTA_RESET=<reset delay>
ACTIONABILITY_API_USERNAME=<username>
ACTIONABILITY_API_PASSWORD=<password>



VERACITY_API_URL=<full_url_of_actionability_api>
VERACITY_QUOTA=<remaining quota>
VERACITY_REQUEST_COST=<cost per request>
VERACITY_QUOTA_RESET=<reset delay>
VERACITY_API_USERNAME=<username>
VERACITY_API_PASSWORD=<password>


```

And finally, add the following to your `/etc/hosts` file:

```
192.168.22.4 comrades-service-proxy.dev
```

Go to http://comrades-service-proxy.dev/ in your browser to verify that everything worked.
