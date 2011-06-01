#!/bin/make

gendoc:
	@rm -rf doc/*
	@mkdir doc/ -p
	@phpdoc -d Panorama --target doc/ -o "HTML:Smarty/Evolve:default"

%: gendoc
	
