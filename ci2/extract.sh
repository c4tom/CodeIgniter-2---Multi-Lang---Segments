#!/bin/sh
USER="www-data"
GROUP="www-data"
PATH_LOCALES="locales"


LANGS=$(ls $PATH_LOCALES);

for i in $LANGS
do
	echo "Creating POT file...$i";
	echo > "$PATH_LOCALES/$i/LC_MESSAGES/messages.pot"
	
	# If not exist file, then create it
	if test -e "$PATH_LOCALES/$i/LC_MESSAGES/messages.po"
		then
			echo;
		else
			echo "Creating file...$i";
			echo > "$PATH_LOCALES/$i/LC_MESSAGES/messages.po"
	fi
done

for i in $LANGS
do
	#	--no-location\
	#	--from-code=ASCII\
	xgettext -n -w\
		--default-domain=messages\
		--indent\
		--omit-header \
		--sort-output \
		--join-existing\
		--force-po\
		--keyword=__\
		--from-code=UTF-8\
		--debug\
		--copyright-holder="2011 Copyright CHT"\
		`find . -name "*.php"` -o "$PATH_LOCALES/$i/LC_MESSAGES/messages.pot"
		
		msgmerge -v --no-wrap "$PATH_LOCALES/$i/LC_MESSAGES/messages.po" "$PATH_LOCALES/$i/LC_MESSAGES/messages.pot" > /tmp/po
		chmod 666 /tmp/po
		cp -f /tmp/po "$PATH_LOCALES/$i/LC_MESSAGES/messages.po"
		msgfmt --statistics -v  -f "$PATH_LOCALES/$i/LC_MESSAGES/messages.po" -o "$PATH_LOCALES/$i/LC_MESSAGES/messages.mo"
done
