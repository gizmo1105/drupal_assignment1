## Authors

- Fuad Poroshtica
- Gissur Már Jónsson
- Hallgrímur Jónas Jensson

## Getting the files:
```bash
git clone https://github.com/FuadPoroshtica/drupal_assignment2.git
cd drupal_assignment2
```

## Run for the first time:

### First Step:
```bash
ddev composer
```
### Second Step:
```bash
ddev import-db --file=database/db.sql.gz
```
### Third Step:
```bash
ddev start
```

## After that, perform the following when you run it in the future:
```bash
ddev launch
```

##### *We love ddev...*
