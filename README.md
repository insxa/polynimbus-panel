[![Build Status](https://travis-ci.org/polynimbus/polynimbus-panel.png?branch=master)](https://travis-ci.org/polynimbus/polynimbus-panel)

![Polynimbus logo](public/assets/logo.png)

## Overview

Polynimbus Panel is a subproject of Polynimbus, multi-cloud infrastructure inventory
and management tool. Panel subproject provides a clean and simple web panel, showing
all servers, databases, storage, domains, serverless objects etc., created across all
cloud accounts configured in Polynimbus.

Using this panel, you can avoid over 90% of switching your browser between accounts
during typical DevOps/SRE work and dramatically increase your productivity.

#### Polynimbus supports the following services and functionalities:

|                       | compute | database | dns     | serverless | storage       |  access management |
|-----------------------|---------|----------|---------|------------|---------------|--------------------|
| Alibaba Cloud         | r/o     |          |         |            |               |                    |
| Amazon Web Services   | full    | r/o      | r/o     | r/o        | S3-only       | detailed           |
| Backblaze B2          |         |          |         |            | all r/o       |                    |
| Beyond e24cloud.com   | full    |          |         |            |               |                    |
| Cloudflare            |         |          | r/o     |            |               | detailed/raw       |
| GoDaddy               |         |          | r/o     |            |               |                    |
| Google Cloud Platform | full    | planned  | planned |            | GS-only       | basic              |
| Hetzner Cloud         | full    |          |         |            |               |                    |
| Hetzner Online        | r/o     |          |         |            |               |                    |
| Linode                | full    |          | r/o     |            | no filelists  | detailed           |
| Microsoft Azure       | full    | sql-only | r/o     | r/o        | all r/o       | detailed           |
| Oracle Cloud          | full    |          |         |            |               |                    |
| Rackspace Cloud       | full    |          |         |            |               |                    |

See Polynimbus documentation page: https://github.com/polynimbus/polynimbus


## Security model

Configuring administrative access to many cloud accounts on a single host (either
running Polynimbus or not) makes it very sensitive to any kind of inappropriate
activities (also internal).

Polynimbus Panel doesn't require any cloud access credentials, and operates only
on files generated by Polynimbus Inventory. Therefore it is provided as a separate
repository, to allow installing on a separate host - in such scenario, the whole
`/var/cache/polynimbus` directory should be rsynced, and host running core Polynimbus
shouldn't expose any other services than ssh.


## Installation

Polynimbus Panel is compatible with any webserver with PHP 5.2 or later. It doesn't
require any database access, unusual extensions, or write access to anything. It is
actively developed and tested using Apache2 with Debian-style configuration, but it
should work everywhere, probably even on Windows.

Manual installation:
- installing classic Apache2/PHP, or Nginx/PHP stack
- setting up a new vhost, or just symlinking `public` subdirectory somewhere inside existing vhost
- setting up proper security measures (eg. password protection) to prevent sharing sensitive data with anyone

#### Basic vhost configuration for Apache2

This is the simplest possible vhost configuration, with **no security at all**:
- no password protection
- no IP protection
- no SSL
- no server hardening
```
<VirtualHost *:80>
    ServerName polynimbus.yournet.internal
    DocumentRoot /var/www/polynimbus-panel/public
    <Directory /var/www/polynimbus-panel/public>
        Options FollowSymLinks
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```


## How to contribute

We are welcome to contributions of any kind: bug fixes, added code comments,
support for new operating system versions, cloud platforms etc.

If you want to contribute:
- fork this repository and clone it to your machine
- create a feature branch and do the change inside it
- push your feature branch to github and create a pull request

## License

|                      |                                          |
|:---------------------|:-----------------------------------------|
| **Author:**          | Tomasz Klim (<opensource@tomaszklim.pl>) |
| **Copyright:**       | Copyright 2015-2020 Tomasz Klim          |
| **License:**         | MIT                                      |

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
