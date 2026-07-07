** Simple Electricity Bill Calculator**

Hi, This is a straightforward, lightweight web app built with **PHP** and **Bootstrap 4** that helps you figure out how much electricity your appliances are gulping down. 

Just punch in the voltage, current, and your local tariff rate, and it instantly spits out a neat 24-hour breakdown showing exactly what it's costing you hour by hour.

---

** What it does**
* **No lost data:** If you make a typo or get an error, the form holds onto what you typed so you don’t have to keep re-entering it (sticky fields).
* **Instant breakdown:** Gives you a clear 24-hour table mapping out Power (kW), Hourly Energy (kWh), and the Total Cost in RM.
* **Basic protection:** Validates inputs on the backend to make sure nobody breaks the math with letters or empty spaces.
* **Looks good on mobile:** Built on Bootstrap 4, so you can easily use it on your phone or tablet.

---

** The Math Behind It**
The app handles the math using standard electrical formulas. Here is how it calculates your bill step-by-step:

1. **Find the Power ($P$):**
   $$P (\text{Watts}) = \text{Voltage (V)} \times \text{Current (A)}$$
   $$\text{Power (kW)} = \frac{P}{1000}$$

2. **Calculate Energy ($E$) for any given hour ($t$):**
   $$\text{Energy (kWh)} = \text{Power (kW)} \times t$$

3. **Calculate the Bill Total (RM):**
   $$\text{Total (RM)} = \text{Energy (kWh)} \times \left(\frac{\text{Rate (sen)}}{100}\right)$$

---

** How to get it running locally**

**What you need:**
* PHP 7.4 or newer running on your machine.
* A local stack environment like **XAMPP**, **WAMP**, or **Laragon**.

**Setup:**
1. **Grab the code:** Drop the `index.php` file into your local server's root folder (for example: `C:/xampp/htdocs/electricity-calculator/`).
2. **Boot up your server:** Open your XAMPP or WAMP control panel and kick off the **Apache** service.
3. **Open it in your browser:** Head over to:
   ```text
   http://localhost/electricity-calculator/index.php