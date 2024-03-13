const CART_STORAGE_KEY = "CART_STORAGE";

class Cart {
    #cart;
    
    /**
     * Get the current car of the user store in the session storage
     * It's not recommended to use the constructor to get the currentCart, use currentCart instead
     */
    constructor() {
        if (!sessionStorage.getItem(CART_STORAGE_KEY)) {
            this.#cart = [];
            sessionStorage.setItem(CART_STORAGE_KEY, JSON.stringify(this.#cart));
        } else {
            this.#cart = JSON.parse(sessionStorage.getItem(CART_STORAGE_KEY));
            for (let i = 0; i < this.#cart.length; i++) {
                this.#cart[i] = CartItem.parseObject(this.#cart[i]);
            }
        }   
    }

    /**
     * Add the given item into the cart.
     * If the item is already in the cart, add the given quantity to it.
     * If not, create a new cartItem and add it in the cart.
     * Negative or zero quantity are not allowed
     * @param {number} itemId The id of the object
     * @param {number} quantity The quantity to add
     */
    addItem(itemId, quantity=1) {
        if (quantity <= 0)
            throw new Error("Can't add item with negative or null quantity");

        let containItem = false;
        let i = 0;
        while (i < this.#cart.length && !containItem) {
            if (this.#cart[i] === itemId) {
                this.#cart[i].add(quantity);
                containItem = true
            }

            i++;
        }

        console.log(this.#cart);
        
        if (!containItem)
            this.#cart.push(new CartItem(itemId, quantity));

        // Update the storage
        this.updateSessionStorage();
    }

    /**
     * Remove the given quantity to the itemId.
     * If the item can't be found, throw a Error
     * If the final quantity is less or equals to zero, it will be remove from the cart
     * @param {number} itemId The id of the item
     * @param {number} quantity The quantity to remove
     */
    remove(itemId, quantity) {
        if (quantity <= 0)
            throw new Error("Quantity can't be negative or null");

        let isPresent = false;
        let i = 0;
        while (i < this.#cart.length) {
            if (this.#cart[i].getItemId() == itemId) {
                this.#cart.remove(quantity);
                isPresent = true;
                if (this.#cart.getQuantity === 0)
                    this.#cart.splice(i, 1);
            }

            i++;
        }

        if (isPresent)
            throw new Error("The item can't be found in the cart");

        // Update the storage
        this.updateSessionStorage();
    }

    /**
     * Remove itemId from the cart.
     * If the item can't be found, throw a Error
     * @param {number} itemId The id of the item
     */
    removeAll(itemId) {
        let isPresent = false;
        let i = 0;
        while (i < this.#cart.length) {
            if (this.#cart[i].getItemId() == itemId) {
                isPresent = true;
                this.#cart.splice(i, 1);
            }

            i++;
        }

        if (isPresent)
            throw new Error("The item can't be found in the cart");

        // Update the storage
        this.updateSessionStorage();
    }

    getNumberOfItem() {
        return this.#cart.length;
    }

    updateSessionStorage() {
        sessionStorage.setItem(CART_STORAGE_KEY, JSON.stringify(this.#cart));
    }

    /**
     * This function go over all the item in the cart, by calling callback with the given parameters
     * - value (CartItem) : the current item
     * - index (number) : the index of the current value
     * @param {function} callback The callback to call
     */
    forEach(callback) {
        this.#cart.forEach((value, index) => {
            callback(value, index);
        });

        // Update the storage
        this.updateSessionStorage();
    }

    toJSON() {
        const list = [];

        this.#cart.forEach((value) => {
            list.push(value.toJSON());
        });
    }
}

/**
 * Define a item in the basket with his id and his quantity
 */
class CartItem {

    #itemId;
    #quantity;

    /**
     * Create a cartItem base on is ID
     * @param {number} itemId the id of the item (base on the dataBase id)
     * @param {number} quantity the number of this item
     */
    constructor(itemId, quantity) {
        this.#itemId = itemId;
        this.setQuantity(quantity);
    }

    /**
     * Add the given quantity to the object.
     * If the result is < 0, the function will set the quantity to 0;
     * @param {number} quantity The number to add
     */
    add(quantity) {
        let newQuantity = quantity + this.getQuantity();
        this.setQuantity(newQuantity < 0 ? 0 : newQuantity);
    }

    /**
     * Remove the given quantity to the object.
     * If the result is < 0, the function will set the quantity to 0;
     * @param {number} quantity The number to remove
     */
    remove(quantity) {
        this.add(-quantity);
    }

    /**
     * Return the id of the currrent basketId
     * @returns The id of the item represent by the object
     */
    getItemId() {
        return this.#itemId;
    }

    /**
     * Return the quantity of the current basketId
     * @returns The quantity of the item represent by the objet
     */
    getQuantity() {
        return this.#quantity;
    }

    /**
     * Set the quantity of the current basketId.
     * If the quantity is < 0, this methods will throw an Error object.""
     * @param {number} quantity The new quantity of the item represent by the object
     */
    setQuantity(quantity) {
        if (quantity < 0)
            throw new Error("Can't set quantity of item into negative value");
        this.#quantity = quantity;
    }

    /**
     * This function parse a given object into a cartItem object.
     * If the needed data aren't in the object, throw an error.
     * @param {object} object The object to parse
     */
    static parseObject(object) {
        const key = Object.keys(object);
        if (!key.includes("itemId") || !key.includes("quantity"))
            throw new TypeError("Can't parse the object, missing field");

        return new CartItem(object.itemId, object.quantity);
    }

    toJSON() {
        return { "itemId": this.getItemId(), "quantity": this.getQuantity() };
    }
}

const currentCart = new Cart();
export default currentCart;
