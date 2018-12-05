# binary-geckodriver

Downloads correct geckodriver version for your development platform, whether it's Linux 
(32bits or 64bits), OSX or Windows.

By default either appropriate version (that matches with installed browser) or latest version of the 
driver will be downloaded.
    
## Configuration

If you want a specific version of GeckoDriver, use:

```json
{
  "extra": {
    "geckodriver": {
      "version": "0.23.0"
    }
  }
}
```

If you don't specify GeckoDriver version, either appropriate version (that matches with installed 
browser) or latest version of the driver will be downloaded.
