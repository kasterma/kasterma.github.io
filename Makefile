.PHONY: stage getdata publish

homepage_dir = /home/kasterma/homepage/
staging_dir = /home/kasterma/kasterma.net/
www_dir = /home/kasterma/kasterma.net/

stage:
	mkdir -p $(staging_dir)images/
	cp -r images/* $(staging_dir)images/
	cp pages/* $(staging_dir)
	mkdir -p $(staging_dir)papers/
	cp papers/* $(staging_dir)papers/

publish:
	echo "Temporarily use stage to publish"
	#rm -rf $(www_dir)/*
	#cp -r $(staging_dir)* $(www_dir)
