---
layout: post
title: Maven exec with multiple goals
---

The [exec maven
plugin](http://www.mojohaus.org/exec-maven-plugin/index.html) allows
to use e.g. `mvn exec:java` to run the program you are working on, or
`mvn exec:exec` to run an arbitrary command.  In several situations I
wanted to run the program with different arguments and different
entrypoints.  Finally I spend the time to set it up correctly.

With the following as build section in my pom

{% highlight xml %}
    <build>
        <plugins>
            <plugin>
                <groupId>org.codehaus.mojo</groupId>
                <artifactId>exec-maven-plugin</artifactId>
                <version>1.6.0</version>
                <executions>
                    <execution>
                        <id>
                            execution-1
                        </id>
                        <goals>
                            <goal>java</goal>
                        </goals>
                        <configuration>
                            <mainClass>
                                com.kpn.datalab.inhome.kstream.App
                            </mainClass>
                            <arguments>
                                <argument>1</argument>
                                <argument>2</argument>
                            </arguments>
                        </configuration>
                    </execution>
                    <execution>
                        <id>
                            execution-2
                        </id>
                        <goals>
                            <goal>java</goal>
                        </goals>
                        <configuration>
                            <mainClass>
                                com.kpn.datalab.inhome.kstream.App
                            </mainClass>
                            <arguments>
                                <argument>111</argument>
                                <argument>222</argument>
                            </arguments>
                        </configuration>
                    </execution>
                    <execution>
                        <id>foo</id>
                        <goals>
                            <goal>exec</goal>
                        </goals>
                        <phase></phase>
                        <configuration>
                            <executable>echo</executable>
                            <arguments>
                                <argument>foooooo</argument>
                            </arguments>
                        </configuration>
                    </execution>
                </executions>
            </plugin>
        </plugins>
    </build>
{% endhighlight %}

I can run commands

    mvn exec:exec@foo
    mvn exec:java@execution-1
    mvn exec:java@execution-2

to get the different sections to execute:

    $ mvn exec:java@execution-1
    [INFO] Scanning for projects...
    [INFO]
    [INFO] ------------------------------------------------------------------------
    [INFO] Building RAE InHome Kafka Stream Test 0.0.1-SNAPSHOT
    [INFO] ------------------------------------------------------------------------
    [INFO]
    [INFO] --- exec-maven-plugin:1.6.0:java (execution-1) @ test1 ---
    Hello World!1
    [INFO] ------------------------------------------------------------------------
    [INFO] BUILD SUCCESS
    [INFO] ------------------------------------------------------------------------
    [INFO] Total time: 0.756 s
    [INFO] Finished at: 2017-07-08T14:38:27+02:00
    [INFO] Final Memory: 7M/155M
    [INFO] ------------------------------------------------------------------------
    ~/projects/rae-inhome-kstream-test (master)  2✎  ❓   12:38:27
    $ mvn exec:java@execution-2
    [INFO] Scanning for projects...
    [INFO]
    [INFO] ------------------------------------------------------------------------
    [INFO] Building RAE InHome Kafka Stream Test 0.0.1-SNAPSHOT
    [INFO] ------------------------------------------------------------------------
    [INFO]
    [INFO] --- exec-maven-plugin:1.6.0:java (execution-2) @ test1 ---
    Hello World!111
    [INFO] ------------------------------------------------------------------------
    [INFO] BUILD SUCCESS
    [INFO] ------------------------------------------------------------------------
    [INFO] Total time: 0.668 s
    [INFO] Finished at: 2017-07-08T14:38:31+02:00
    [INFO] Final Memory: 7M/155M
    [INFO] ------------------------------------------------------------------------
    ~/projects/rae-inhome-kstream-test (master)  2✎  ❓   12:38:31
    $ mvn exec:exec@foo
    [INFO] Scanning for projects...
    [INFO]
    [INFO] ------------------------------------------------------------------------
    [INFO] Building RAE InHome Kafka Stream Test 0.0.1-SNAPSHOT
    [INFO] ------------------------------------------------------------------------
    [INFO]
    [INFO] --- exec-maven-plugin:1.6.0:exec (foo) @ test1 ---
    foooooo
    [INFO] ------------------------------------------------------------------------
    [INFO] BUILD SUCCESS
    [INFO] ------------------------------------------------------------------------
    [INFO] Total time: 0.892 s
    [INFO] Finished at: 2017-07-08T14:38:37+02:00
    [INFO] Final Memory: 7M/155M
    [INFO] ------------------------------------------------------------------------

One nice addition to the aboe is, if you want one of the goals to have a default
execution where you don't have to give the execution id, then give it the execution
id of `default-cli`.