@paying_for_order
Feature: Preventing to pay for the cancelled order
    In order to not be able to buy order that is already cancelled
    As a Customer
    I want to be prevented from paying for the cancelled order

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "Iron Maiden T-Shirt"
        And "Iron Maiden T-Shirt" product is tracked by the inventory
        And there are 5 units of product "Iron Maiden T-Shirt" available in the inventory
        And the store ships everywhere for Free
        And the store allows paying Offline
        And there is a customer "sylius@example.com" that placed an order "#00000022"

    @api @ui
    Scenario: Not being able to pay for cancelled order
        Given the customer bought 3 "Iron Maiden T-Shirt" products
        And the customer chose "Free" shipping method to "United States" with "Offline" payment
        And this order was cancelled
        When I want to browse order details for this order
        Then I should not be able to pay
