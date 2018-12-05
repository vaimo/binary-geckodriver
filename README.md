# binary-geckodriver

Downloads correct geckodriver version for your development platform, whether it's Linux 
(32bits or 64bits), OSX or Windows.

The plugin will either:

* downloads driver for the browser that is currently installed
* downloads driver for specified/configured version (see below under 'Configuration' topic)
    
## Configuration

Although the binary downloader usually ends up positively detecting the appropriate driver version that needs to be downloaded, user still has an option to specify the version explicity when needed.

```json
{
  "extra": {
    "geckodriver": {
      "version": "0.23.0"
    }
  }
}
```
