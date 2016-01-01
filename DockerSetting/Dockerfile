FROM chug/ubuntu14.04x64
MAINTAINER Youngje-Jo

RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main universe" > /etc/apt/sources.list
RUN apt-get update # 최신 버젼 업데이트

RUN apt-get install -y gcc # c 컴파일러
RUN apt-get install -y g++ # c++ compiler

# back-end compiler
RUN apt-get install -y ruby # ruby compiler
RUN apt-get install -y python # python compiler
RUN apt-get install -y php5-cli # php compiler
RUN apt-get install -y nodejs # nodejs compiler
RUN apt-get install -y golang-go # go compiler

# java Download
RUN apt-get install -y python-software-properties
RUN apt-get install -y software-properties-common


RUN add-apt-repository -y ppa:webupd8team/java
RUN apt-get update
RUN echo oracle-java7-installer shared/accepted-oracle-license-v1-1 select true | /usr/bin/debconf-set-selections








