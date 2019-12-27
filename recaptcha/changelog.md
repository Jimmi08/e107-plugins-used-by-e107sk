
# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Versioning Guidelines
All versioning should attempt to follow the Semantic Versioning guidelines.

Given a version number MAJOR.MINOR.PATCH (e.g v0.0.0), increment the:

MAJOR version when you make incompatible API changes,
MINOR version when you add functionality in a backwards-compatible manner, and
PATCH version when you make backwards-compatible bug fixes.
 
## [1.3.0] - 2019-12-27
### Added 
**[rescan plugin directory is needed]**
- added shortcode {RECAPTCHA} for using mainly in contact template, see issue #3980
- added pref Hide from members - to hide recaptcha field for log in users, again for contact template

It's possible to use recaptcha for any form, just need to add test there:

```
if (isset($_POST['rand_num']) && !e107::getSecureImg()->verify_code($_POST['rand_num'], $_POST['code_verify']))
{
	//your error message
}
```

## [1.2.1] - 2018-08-29

## [1.2.0] - 2018-08-14

## [1.1.0] - 2017-04-10
initial release

 