define(
    [
        'jquery',
        'ko',
        'uiComponent',
    ],
    function ($, ko, component) {
        "use strict";
        function SeatReservation(name, initialMeal) {
            var self = this;
            self.name = name;
            self.meal = ko.observable(initialMeal);
            self.formattedPrice = ko.computed(function() {
                var price = self.meal().price;
                return price ? "$" + price.toFixed(2) : "None";
            });
        }

        return component.extend({
            seats: ko.observableArray([]),
            names: ko.observableArray(['Henry','Chirag']),
            availableMeals : ko.observableArray([
                { mealName: "Standard (sandwich)", price: 5 },
                { mealName: "Premium (lobster)", price: 14.95 },
                { mealName: "Ultimate (two lobster)", price: 25 }
                ]),
            addSeat : function() {
                var seat = new SeatReservation ("",this.availableMeals()[0]);
                this.seats.push(seat);
            },
            removeSeat : function(parent,seat) {
                parent.seats.remove(seat);

            },

            addMeal:function(meals){
                for (var i in meals){
                    this.availableMeals.push(meals[i]);
                }

            },

            totalSurcharge : function() {
                var total = 0;
                for (var i = 0; i < this.seats().length; i++)
                    total += this.seats()[i].meal().price;
                return total;
            },

            initialize: function () {
                this._super();
                this._render();

            },

            _render:function(){
                var self = this;
                for (var i = 0; i < this.names().length; i++){
                    // console.log(i)
                    this.seats.push(new SeatReservation (this.names()[i],this.availableMeals()[0]));
                }
            },

            defaults: {
                template: 'Geekhub_Lesson7/grid',
            },
        });
    }
);
