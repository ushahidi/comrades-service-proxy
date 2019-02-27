[download]: https://github.com/ushahidi/comrades-service-proxy/releases
[install]: docs/install.md
[docs]: docs/
[issues]: https://github.com/ushahidi/comrades-service-proxy/issues
[ushahidi]: http://ushahidi.com
[ushahidi platform]: https://github.com/ushahidi/platform
[yodie]: https://gate.ac.uk/applications/yodie.html
[platform post]: http://github.ushahidi.org/platform/docs/api/index.html#posts
![COMRADES Logo](Associated_Files/COMRADES_logo.png)

Comrades Service Proxy
============

[Download][download]

[Installation Guide][install]

The [Configuration & Set-up Manual for the COMRADES Platform can be found here](https://s3-eu-west-1.amazonaws.com/comradesmanual/Comrades+Manual/COMRADES+Config+Setup+Manual.pdf). 

## What is CSP?

The Comrades Service Proxy is designed as an intermediary web adapter which allows for the automated annotation via [Yodie][yodie] of [Ushahidi Platform][ushahidi platform] Posts and automated categorisation of Posts via the Open University Crees tool.

## How does CSP work?

This tool receives inbound HTTP POST requests, transforms them into a Yodie/Crees/EMINA formatted request and retrieves an annotation/label for the given request data. The annotated/labeled data is formatted as an [Ushahidi Platform Post][platform post] and sent to a pre-configured Ushahidi Platform API instance.

Authentication works using a shared secret which must be configured on both the [Ushahidi Platform][ushahidi platform] and the CSP instances. HTTP Requests and Responses are signed with this secret using SHA256.

## Useful Links

- [Download][download]
- [Installation Guide][install]
- [Documentation][docs]
- [Bug tracker][issues]
- [Ushahidi][ushahidi]

## References
This is one of three repositories related to COMRADES deployment of Ushahidi, [which is being tested here](https://comrades-stg.ushahidi.com/views/map).
* The test deployment also connects to other web services. In this repo you will find code for an intermediary proxy which uses [YODIE from the University of Sheffield](https://gate.ac.uk/applications/yodie.html) to annotate posts in the COMRADES test Platform.
* The primary source code for the functionality of the platform can be found in the [“Platform-comrades” repo here](https://github.com/ushahidi/platform-comrades). The “development” branch is our sandbox and the “master” branch is production.
* The [platform-client-comrades repo](https://github.com/ushahidi/platform-client-comrades) contains code for the deployment’s graphical user interface. The “development” branch is our sandbox and the “master” branch is production.
* The project website for this [COMRADES H2020 European Project](http://www.comrades-project.eu) can be found here. It contains a variety of outputs from the project such as [specific documentation within reports](http://www.comrades-project.eu/outputs/deliverables.html), access to our training [data and ontologies](http://www.comrades-project.eu/outputs/datasets-and-ontologies.html), and [academic research](http://www.comrades-project.eu/outputs/papers.html). 

## Acknowledgment
This work has received support from the European Union’s Horizon 2020 research and innovation programme under [grant agreement No 687847](http://cordis.europa.eu/project/rcn/198819_en.html).
