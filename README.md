# binary-geckodriver

[![Latest Stable Version](https://poser.pugx.org/vaimo/binary-geckodriver/v/stable)](https://packagist.org/packages/vaimo/binary-geckodriver)
[![Total Downloads](https://poser.pugx.org/vaimo/binary-geckodriver/downloads)](https://packagist.org/packages/vaimo/binary-geckodriver)
[![Daily Downloads](https://poser.pugx.org/vaimo/binary-geckodriver/d/daily)](https://packagist.org/packages/vaimo/binary-geckodriver)
[![License](https://poser.pugx.org/vaimo/binary-geckodriver/license)](https://packagist.org/packages/vaimo/binary-geckodriver)

Downloads geckodriver binary for Linux (32bits or 64bits), macOS (Mac OS X) and Windows. 

The binary version is determined by the following factors:

* what browser version is currently installed (if binary found from the system).
* specified/configured version (see below under 'Configuration' topic)
    
More information on recent changes [HERE](./CHANGELOG.md).

## Configuration

Although the binary downloader usually ends up positively detecting the appropriate 
driver version that needs to be downloaded, user still has an option to specify the 
version explicitly when needed.

```json
{
  "extra": {
    "geckodriver": {
      "version": "0.23.0"
    }
  }
}
```
