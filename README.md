# sulu-robotstxt-bundle

This is a Sulu Bundle to manage `robots.txt` files for your Sulu webspaces.

`robots.txt` tells search engine crawlers which parts of your site they may or may not access. This bundle lets
editors manage the raw content of that file per webspace from the Sulu admin, without touching code or the filesystem.

## Installation

```bash
composer require bitexpert/sulu-robotstxt-bundle
```

1. Register the bundle in the file `config/bundles.php`
```php
BitExpert\Sulu\RobotstxtBundle\BitExpertSuluRobotstxtBundle::class => ['all' => true],
```

2. Configure the routing as follows:

Create file `config/routes/robotstxt_admin.yaml`:
```yaml
robotstxt_api:
    resource: "@BitExpertSuluRobotstxtBundle/Resources/config/routing_api.yaml"
```

Create file `config/routes/robotstxt_website.yaml`:
```yaml
robotstxt_website:
  resource: "@BitExpertSuluRobotstxtBundle/Resources/config/routing_website.yaml"
```

3. Run Doctrine Schema Update
```bash
./bin/adminconsole doctrine:schema:update -f
```

## Usage

Once installed, this bundle adds a tab called "Robots.txt" to the webspaces configuration which allows you to create
a new robots.txt entry for each webspace. For each webspace only one robots.txt configuration can be saved, and its
raw content is served as-is at `/robots.txt`.

Only users with the Robotstxt permissions can view, add, edit or delete the robots.txt entries.

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! To establish
a consistent code quality, please provide unit tests for all your changes and adapt the documentation.

## Want To Contribute?

If you feel that you have something to share, then we’d love to have you.
Check out [the contributing guide](CONTRIBUTING.md) to find out how, as well as what we expect from you.

## License

Sulu Robots.txt Bundle is released under the MIT License.