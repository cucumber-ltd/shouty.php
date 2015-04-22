Feature: Hear shout

  Rules:
  - Must be within 1 km
  - Displayed in order of creation
  - Network and geo location must be enabled

  Notes:
  - Display error when no geo or network

  Assumptions:
  - Everybody has geo location and network
  - University of Oxford and Balliol College are close
  - Trafalgar Square is far from the other locations

  Questions:
  - Should people hear their own messages?

  Background:
    Given the following locations:
      | name                   | lat        | lon        |
      | University of Oxford   | 51.7564016 | -1.2547147 |
      | Balliol College        | 51.7550014 | -1.2580754 |
      | Trafalgar Square       | 51.508039  | -0.128069  |

  Scenario: Phil can't hear Jeff who is far away
    Given Jeff is in University of Oxford
    And Phil is in Trafalgar Square
    When Jeff shouts
    Then Phil should not hear anything

  Scenario: Phil can hear Sally who is within range
    Given Sally is in University of Oxford
    And Phil is in Balliol College
    When Sally shouts "You around Phil?"
    Then Phil should hear "You around Phil?"
