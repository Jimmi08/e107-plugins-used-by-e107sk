#cookie solution by Insites

https://cookieconsent.insites.com/

To be GDPR compliance you need:
- set compliance type to opt-out or opt-in according your local low
- to check your cookies for value of $_COOKIE['cookieconsent_status']

Example (values: dismiss, allow, deny):

```
if ( $_COOKIE['cookieconsent_status'] != "deny"  AND $_COOKIE['cookieconsent_status'] ) { 
 
  	<?php } 
} else {
 
}
```