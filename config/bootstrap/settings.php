<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use cms_core\extensions\cms\Settings;

Settings::register('cms_core', 'project.name', PROJECT_NAME);
Settings::register('cms_core', 'project.version', PROJECT_VERSION);
Settings::register('cms_core', 'site.title');

// FIXME Use a pseudo number generator seeded with project
// name to generate cookie secret. Simple md5'ing wont work as
// there the alphabet would be too limited for a password style string.
Settings::register('cms_core', 'security.cookieSecret', 'alsFDDT§$sdfs');

Settings::register('cms_core', 'contact.default.name');
Settings::register('cms_core', 'contact.default.type'); // organization or person
Settings::register('cms_core', 'contact.default.email');
Settings::register('cms_core', 'contact.default.phone');
Settings::register('cms_core', 'contact.default.website');
Settings::register('cms_core', 'contact.default.street_address');
Settings::register('cms_core', 'contact.default.postal_code');
Settings::register('cms_core', 'contact.default.city');
Settings::register('cms_core', 'contact.default.country');
Settings::register('cms_core', 'contact.default.district');

Settings::register('cms_core', 'contact.exec.name');
Settings::register('cms_core', 'contact.exec.type');
Settings::register('cms_core', 'contact.exec.email');
Settings::register('cms_core', 'contact.exec.phone');
Settings::register('cms_core', 'contact.exec.website');
Settings::register('cms_core', 'contact.exec.street_address');
Settings::register('cms_core', 'contact.exec.postal_code');
Settings::register('cms_core', 'contact.exec.city');
Settings::register('cms_core', 'contact.exec.country');
Settings::register('cms_core', 'contact.exec.district');

Settings::register('cms_core', 'service.googleAnalytics.default.account');
Settings::register('cms_core', 'service.googleAnalytics.default.domain');
Settings::register('cms_core', 'service.googleAnalytics.default.propertyId');

Settings::register('cms_core', 'user.number', [
	'sort' => '/([0-9]{4}-[0-9]{4})/',
	'extract' => '/[0-9]{4}-([0-9]{4})/',
	'generate' => '%Y-%04.d'
]);

?>