.PHONY: stage getdata publish

staging_dir = ~/staging.www.bartk.nl/
www_dir = ~/www.kasterma.net/

stage:
	mkdir -p $(staging_dir)images/
	cp images/* $(staging_dir)images/
	cp pages/* $(staging_dir)
	cp -r computingPages/* $(staging_dir)
	mkdir -p $(staging_dir)papers/
	cp papers/* $(staging_dir)papers/

publish:
	rm -rf $(www_dir)/*
	cp -r $(staging_dir)* $(www_dir)

getdata_staging:
	cd getdata; python get_data.py > $(staging_dir)out.html

getdata:
	cd getdata; python get_data.py > $(www_dir)out.html
