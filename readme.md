[download]: https://github.com/ushahidi/comrades-yodie-proxy/releases
[install]: https://github.com/ushahidi/comrades-yodie-proxy/docs/install.md
[docs]: https://github.com/ushahidi/comrades-yodie-proxy/docs
[issues]: https://github.com/ushahidi/comrades-yodie-proxy/issues
[ushahidi]: http://ushahidi.com
[ushahidi platform]: https://github.com/ushahidi/platform
[yodie]: https://gate.ac.uk/applications/yodie.html
[platform post]: http://github.ushahidi.org/platform/docs/api/index.html#posts

Comrades Yodie Proxy
============

[Download][download]

[Installation Guide][install]

## What is CYP?

The Comrades Yodie Proxy is designed as an intermediary web adapter which allows for the automated annotation via [Yodie][yodie] of [Ushahidi Platform][ushahidi platform] Posts.

## How does CYP work?

This tool receives inbound HTTP POST requests, transforms them into a Yodie formatted request and retrieves an annotation for the given request data. The annotated data is formatted as an [Ushahidi Platform Post][platform post] and sent to a pre-configured Ushahidi Platform API instance.

Authentication works using a shared secret which must be configured on both the [Ushahidi Platform][ushahidi platform] and the CYP instances. HTTP Requests and Responses are signed with this secret using SHA256.

## Useful Links

- [Download][download]
- [Installation Guide][install]
- [Documentation][docs]
- [Bug tracker][issues]
- [Ushahidi][ushahidi]
