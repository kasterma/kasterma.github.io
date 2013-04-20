.PHONY: stage getdata publish

homepage_dir = /home/kasterma/homepage/
staging_dir = /home/kasterma/kasterma.net/
www_dir = /home/kasterma/kasterma.net/
BLOGDIR= /home/kasterma/zotskolf.nl/

stage:
	mkdir -p $(staging_dir)images/
	cp images/* $(staging_dir)images/
	cp pages/* $(staging_dir)
	cp -r computingPages/* $(staging_dir)
	mkdir -p $(staging_dir)papers/
	cp papers/* $(staging_dir)papers/

publish:
	echo "Temporarily use stage to publish"
	#rm -rf $(www_dir)/*
	#cp -r $(staging_dir)* $(www_dir)

getdata_staging:
	cd $(homepage_dir)getdata; python get_data.py > $(staging_dir)out.html

getdata:
	cd $(homepage_dir)getdata; python get_data.py > $(www_dir)out.html

pushblog:
	cp $(homepage_dir)pages/bkstyle.php $(BLOGDIR)
	cp $(homepage_dir)pages/menu.php $(BLOGDIR)
	cp $(homepage_dir)pages/menudf.incl $(BLOGDIR)
	cp $(homepage_dir)blog/* $(BLOGDIR)