.PHONY: stage getdata publish

staging_dir = ~/kasterma.net/
www_dir = ~/kasterma.net/

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
	cd getdata; python get_data.py > $(staging_dir)out.html

getdata:
	cd getdata; python get_data.py > $(www_dir)out.html
