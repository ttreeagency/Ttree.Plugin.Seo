A SEO plugin for TYPO3 Neos
===========================

**This package is NOT MAINTAINED ANYMORE**.

This package for the Content Management System TYPO3 Neos offer some nice feature for search engine optimizations (SEO).

The logic of this package is done in TypoScript2, so you can customize the rendering to fit your needs.

created by Dominique Feyer <dfeyer@ttree.ch> http://www.ttree.ch

Features
========

- Page title generation
- META tag
- OpenGraph
- Twitter Card

Installation
============
Add this to your composer.json and run `composer update`::

	{
	    "repositories": [
	        {
	            "type": "git",
	            "url": "https://github.com/ttreeagency/Ttree.Plugin.Seo.git"
	        }
	    ],
	    "require": {
	        "ttree/plugin-seo": "dev-master"
	    },
	}

Configuration
=============

Include the TypoScript file NodeTypes.ts2 in your site's TypoScript::

	include: resource://Ttree.Plugin.Seo/Private/TypoScripts/Library/NodeTypes.ts2

How to use the plugin ?
=======================

Use the TS2 object 'Ttree.Plugin.Seo:MetaTags' to generate the HTML meta tags.

How to generate your page title ?
=================================

You can use the object 'Ttree.Plugin.Seo:PageTitle' to generate your page title. By the default the page title contain the
current page title, with a static suffix. You need to add this snippet to your Page TS2::

	page = Page {
		head {
			title = Ttree.Plugin.Seo:PageTitle {
				@position = 'after characterSetMetaTag'
			}
		}
	}

You can change the static part of the title, in your TS2, like this::

	prototype(Ttree.Plugin.Seo:StaticPageTitle) {
  		value = 'your company - fixed suffix'
	}

If you need a static prefix, even if it's not a good practice in term of SEO, use this TS2::

	prototype(Ttree.Plugin.Seo:PageTitle) {
		value = ${this.staticTitle + " - " + this.pageTitle}
	}

Has we use EEL for processing the value of the title, more complex configurations can offer a lots of flexibility.

Per exemple you have a specific Node Type for you blog post, you can prefix all the blog page with a specific static prefix, like this::

	prototype(Ttree.Plugin.Seo:PageTitle) {
		@process.blog = ${q(documentNode).is('[instanceof Ttree.Plugin.Blog:Blog]') ? 'Blog - ' + value : value}
	}

You need a more specific title for your page ?
----------------------------------------------

By default the PageTitle object use the node title, the same used for your navigation menu. In some case you need a more specific title. In this
case you can use the inspector, in the group "SEO / Generic", fill the property "Title". This title will be used for the HTML page title tag,
Opengraph and Twitter Card. In the group "SEO / OpenGraph" and "SEO / Twitter Card", if you fill the property title, you can target this property.

How to generate your page meta tags ?
=====================================

You just need to update your TS2, like this::

	page = Page {
		head {
			metaTags = Ttree.Plugin.Seo:MetaTags {
				@position = 'after characterSetMetaTag'
			}
		}
	}

How to generate a Twitter Card
==============================

To enable Twitter Card rendering, go to the Inspector Group "SEO / Twitter Card", and check "Enable Twitter Card". By default the card will use the page Title
and extract automatically a teaser for the current page, by using the TS2 Object "Ttree.Plugin.Seo:DocumentTeaser". You can provide a custom title and
description if needed. Take care to fill the field "Site" and "Creator" to have a valid Twitter Card.

How to force the rendering of a Twitter Card
--------------------------------------------

In some case, like for a blog post, you need the force the rendering of the Twitter Card. For this to work you need a specific Node Type for this kind of Document.
You can use this TS2 snippet to force the rendering of the Twitter Card::

	prototype(Ttree.Plugin.Seo:TwitterCard) {
		hasTwitterCard.@process.event = ${q(documentNode).is('[instanceof Ttree.Plugin.Blog:Blog]') ? TRUE : value}
	}

How to force the content for the property Site and Creator
----------------------------------------------------------

::

	prototype(Ttree.Plugin.Seo:TwitterCardAbstract) {
		twitterSite = '@ttreeagency'
		twitterCreator = '@dfeyer'
	}
