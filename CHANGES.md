# Changes History

1.0.7
-----
Add rules for validation phone number.

1.0.6
-----
Resolve "Presence verifier has not been set." issue for **exists** and **in** rules

1.0.5
-----
Add ability to use custom declared validation rules

1.0.4
-----
Add 'sometimes' rule modifier

1.0.3
-----
Add ServiceProvider - allows to use rule builder without explicit ->toString()

1.0.1, 1.0.2
-----
Add more rules, tests, and inline documentation

1.0.0
-----
Basic rules:
- required
- required_with
- required_without

String rules:
- string
- regex
- email

Int rules:
- int
- min
- max
