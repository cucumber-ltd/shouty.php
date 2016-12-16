Feature: Hear Shout

  Shouts have a range of approximately 1000m

  Background:
    Given Lucy is at [0, 0]

  Scenario Outline: Shouts only heard in-range
    Given Sean is at <shout location>
    When Sean shouts
    Then Lucy should <hear>

    Examples:
      | shout location | hear         |
      | [0, 900]       | hear Sean    |
      | [0, 1100]      | hear nothing |

  Scenario: Multiple shouters
    Given people are located at
      | name  | x   | y    |
      | Sean  | 500 | 0    |
      | Oscar | 0   | 1100 |
    When Sean shouts
    And Oscar shouts
    Then Lucy should not hear Oscar
    But Lucy should hear Sean

  Scenario: Shouter doesn't hear echos
    When Lucy shouts
    Then Lucy should not hear Lucy

  Scenario: Multiple shouts from one person
    Given Sean is at [0, 500]
    When Sean shouts
    And Sean shouts
    Then Lucy should hear 2 shouts from Sean