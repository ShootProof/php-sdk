php-sdk
=======

A PHP SDK to interact with the ShootProof API. API and Auth documentation can be found at http://developer.shootproof.com.

This is just a wrapper for the shootproof SDK that is available at http://developer.shootproof.com/code

You will need to add this to your composer.json file.
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/shootproof/php-sdk"
        }
    ]
```

along with actually requiring that SDK:
```json
   "require": {
      "shootproof/php-sdk" : "master"
   }

```
