#!/bin/make

all: gendoc test
	
gendoc:
	@rm -rf doc/*
	@mkdir doc/ -p
	phpdoc -d Panorama --target doc/ -o "HTML:Smarty/Evolve:default"
	
test:
	@cd features
	@behat . 2> /dev/null

