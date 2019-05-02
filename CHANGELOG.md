# Changelog

_This file has been auto-generated from the contents of changelog.json_

## 2.0.3 (2019-05-03)

### Fix

* wrong kind of extraction pattern provided for version poller (sscanf pattern used but code behind the scenes was expecting RegEx)

### Maintenance

* introduced the use of Static Code Analysis tools
* code downgraded so to make the package installable on relatively old php versions


## 2.0.2 (2019-02-27)

### Fix

* added latest gecko-driver reference


## 2.0.1 (2018-12-12)

### Fix

* bad unescaped path configured for browser binary for Windows which resulted in version polling not working


## 2.0.0 (2018-12-12)

### Breaking

* (code) started to rely on external general-issue library for most of the implementation; only configuration remains in this package

### Feature

* support for browser version detection added for Windows


## 1.0.0 (2018-12-05)

### Feature

* download specified version of geckodriver
* detect installed browser version when possible (when Firefox installed)