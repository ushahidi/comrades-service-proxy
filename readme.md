[download]: https://github.com/ushahidi/comrades-service-proxy/releases
[install]: docs/install.md
[docs]: docs/
[issues]: https://github.com/ushahidi/comrades-service-proxy/issues
[ushahidi]: http://ushahidi.com
[ushahidi platform]: https://github.com/ushahidi/platform
[yodie]: https://gate.ac.uk/applications/yodie.html
[platform post]: http://github.ushahidi.org/platform/docs/api/index.html#posts

Comrades Service Proxy
============

[Download][download]

[Installation Guide][install]

## What is CSP?

The Comrades Service Proxy is designed as an intermediary web adapter which allows for the automated annotation via [Yodie][yodie] of [Ushahidi Platform][ushahidi platform] Posts and automated categorisation of Posts via the Open University Crees tool.

## How does CYP work?

This tool receives inbound HTTP POST requests, transforms them into a Yodie/Crees formatted request and retrieves an annotation/label for the given request data. The annotated/labeled data is formatted as an [Ushahidi Platform Post][platform post] and sent to a pre-configured Ushahidi Platform API instance.

Authentication works using a shared secret which must be configured on both the [Ushahidi Platform][ushahidi platform] and the CSP instances. HTTP Requests and Responses are signed with this secret using SHA256.

## Useful Links

- [Download][download]
- [Installation Guide][install]
- [Documentation][docs]
- [Bug tracker][issues]
- [Ushahidi][ushahidi]
