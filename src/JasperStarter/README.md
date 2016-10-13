
JasperStarter - Running JasperReports from command line
--------------------------------------------------------

JasperStarter is an opensource command line launcher and batch compiler for
[JasperReports][].

The official homepage is [jasperstater.cenote.de][].

It has the following features:

  * Run any JasperReport that needs a jdbc, csv, xml, json or empty datasource
  * Use with any database for which a jdbc driver is available
  * Run reports with subreports
  * Execute reports that need runtime parameters. Any parameter whose class has
    a string constructor is accepted. Additionally the following types are
    supported or have special handlers:
    * date, image (see usage), locale
  * Optionally prompt for report parameters
  * Print directly to system default or given printer
  * Optionally show printer dialog to choose printer
  * Optionally show printpreview
  * Export to file in the following formats:
    * pdf, rtf, xls, xlsMeta, xlsx, docx, odt, ods, pptx, csv, csvMeta, html, xhtml, xml, jrprint
  * Export multiple formats in one commanding call
  * Compile, print and export in one commanding call
  * View, print or export previously filled reports (use jrprint file as input)
  * Can compile a whole directory of .jrxml files.
  * Integrate in non Java applications (for example PHP, Python)
  * Binary executable on Windows
  * Includes JasperReports so this is the only tool you need to install

Requirements:

  * Java 1.6 or higher
  * A JDBC 2.1 driver for your database


### Quickstart

  * Download JasperStarter from [Sourceforge][].
  * Extract the distribution archive to any directory on your system.
  * Add the _./bin_ directory of your installation to your searchpath (on
    Windows: invoke setup.exe).
  * Put your jdbc drivers in the _./jdbc_ directory of your installation or
    use _\--jdbc-dir_ to point to a different directory.

Invoke JasperStarter with _\-h_ to get an overview:

    $ jasperstarter -h

Invoke JasperStarter with _process \-h_ to get help on the process command:

    $ jasperstarter process -h

Example with reportparameters:

    $ jasperstarter pr report.jasper -t mysql -u myuser -f pdf -H myhost \
     -n mydb -o report -p secret -P CustomerNo=10 StartFrom=2012-10-01

Example with hsql using database type generic:

    $ jasperstarter pr report.jasper -t generic -f pdf -o report -u sa \
    --db-driver org.hsqldb.jdbcDriver \
    --db-url jdbc:hsqldb:hsql://localhost

For more information take a look in the docs directory of the distibution
archive or read the [Usage][] page online.


### Release Notes

See [Changes] for a history of changes.


#### Known Bugs

For upcoming issues see [Issues][]


### Feedback

Feedback is always welcome! If you have any questions or proposals, don't
hesitate to write to our [discussion][] forum.
If you found a bug or you are missing a feature, log into our [Issuetracker][]
and create a bug or feature request.

If you like the software you can write a [review][] :-)


### Developement

The sourcecode is available at [bitbucket.org/cenote/jasperstarter][], the
project website is hosted at [Sourceforge][].

JasperStarter is build with [Maven][]. 

Unfortunately one dependency (jasperreports-functions) is not provided
in a public maven repository so you must add it to your local maven
repo:

    # Download jasperreports-functions-6.1.0.jar from
    # https://sourceforge.net/projects/jasperreports/files/jasperreports/
    $ jar xvf jasperreports-functions-6.1.0.jar META-INF/maven/net.sf.jasperreports/jasperreports-functions/pom.xml
    $ mvn install:install-file -Dfile=jasperreports-functions-6.1.0.jar -DpomFile=META-INF/maven/net.sf.jasperreports/jasperreports-functions/pom.xml

See https://maven.apache.org/guides/mini/guide-3rd-party-jars-local.html

It is possible to compile JasperStarter without this dependency but users
will run into errors if they use specific functions in their reports.
So there is a test that fails if jasperreports-functions is not available.

On Linux 64 bit the launch4j-maven-plugin may fail. You need the folloing libs in a 32 bit version:

  * z1
  * ncurses5
  * bz2-1.0

On Ubuntu 14.04 for example use this command:

    $ sudo apt-get install lib32z1 lib32ncurses5 lib32bz2-1.0


To get a distribution package run:

    $ mvn package -P release

or if you build from the current default branch you better use:

    $ mvn package -P release,snapshot

**Attention! You cannot execute** `target/jasperstarter.jar`
**without having it\'s dependencies in** `../lib` ! See **dev** profile below!

If you want to build the Windows setup.exe, you need to have _nsis_ in your
search path (works on linux too, you can find a compiled release in the 
sourceforge download folder _build-tools_ for your convenience)
an add the **windows-setup** profile to your build:

    $ mvn package -P release,windows-setup

or

    $ mvn package -P release,windows-setup,snapshot

While developing you may want to have a quicker build. The **dev** profile
excludes some long running reports and the compressed archives. Instead it puts
the build result into _target/jasperstarter-dev-bin_.

    $ mvn package -P dev

Now you can execute JasperStarter without IDE:

    $ target/jasperstarter-dev-bin/bin/jasperstarter

or

    $ java -jar target/jasperstarter-dev-bin/lib/jasperstarter.jar

During development you might want not to be annoyed by tests. So the following
options are useful:

    $ mvn package -P dev -D skipTests

or

    $ mvn package -P dev -D maven.test.failure.ignore=true

To run JasperStarter from within your IDE add _\--jdbc-dir jdbc_ to the argument
list of your run configuration. Otherwise you will get an error:

    Error, (...)/JasperStarter/target/classes/jdbc is not a directory!

Put your jdbc drivers in the _./jdbc_ directory of the project to invoke
JasperStarter from within your IDE to call up a database based report.


### License

Copyright 2012-2015 Cenote GmbH.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

[jasperstater.cenote.de]:http://jasperstarter.cenote.de/
[JasperReports]:http://community.jaspersoft.com/project/jasperreports-library
[Maven]:http://maven.apache.org/
[Sourceforge]:http://sourceforge.net/projects/jasperstarter/
[bitbucket.org/cenote/jasperstarter]:http://bitbucket.org/cenote/jasperstarter
[review]:http://sourceforge.net/projects/jasperstarter/reviews
[discussion]:http://sourceforge.net/p/jasperstarter/discussion/
[Issuetracker]:https://cenote-issues.atlassian.net/browse/JAS
[Usage]:http://jasperstarter.sourceforge.net/usage.html
[Issues]:https://cenote-issues.atlassian.net/browse/JAS
[Changes]:changes.html
