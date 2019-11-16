# PiTS Browser/Raspberry Pi Application

PiTS stands for Pi Temperature Sensor. The goal is to have an application that runs on the pi and measures Sensors via 
the 1-wire protocol.

## Installation

### 1 Download Software

**Attention:** The sourcecode should be directly installed by the 
webserver's user to avoid access right issues. Alternativly see "2".

```bash
git clone https://github.com/pmaasz/PiTS.git
```

### 2 Configutrate Access Rights (not required)

```bash
sudo chown www-data:www-data [Filename] -R
sudo chmod 2775 [Filename] -R
```

### 3 Composer Install

First make sure composer is installed on the target device.
Then run the following command in the docroot of this project:

````bash
composer install
````

### 4 Configure Database

Configure the config.json file in the config/ directory. 

### 5 Create Directories For Files

Create the following directories to enable downloads and csv backups when the Database connection is not working:

<li>
    create a directory named "files" in the docroot of PiTS
</li>
<li>
    create a directory named "measurements" in the files directory
</li>
<li>
    create a directory named "downloads" in the files directory
</li>

### possible new features: 
- no more composer by adding an autoloader to the project
- setup service to detect the sensors
- different sensor support
- FileService 
- MigrationService
- csv downloads
