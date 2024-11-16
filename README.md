# Book2Go

Platform for Booking and Managing Services

![Book2Go Logo](https://i.imgur.com/KxfCFcw.png)

## Table of Contents

-   [About Book2Go](#about-book2go)
-   [Features](#features)
-   [Installation](#installation)
-   [Usage](#usage)
-   [Contributing](#contributing)
-   [License](#license)
-   [Contact](#contact)

## About Book2Go

Book2Go is a versatile platform designed to streamline the process of booking and managing services. With a focus on user experience, it provides a seamless interface for users and service providers alike. Built using PHP and Blade, Book2Go is robust, secure, and easy to deploy.

## Features

-   **Service Booking**: Effortlessly book services through an intuitive and streamlined interface.
-   **Service Management**: Manage service offerings, schedules, and availability with ease.
-   **User Authentication**: Secure and reliable login and registration systems.
-   **Real-time Notifications**: Stay informed with instant notifications for bookings, cancellations, and updates.
-   **Responsive Design**: Accessible on all devices, providing a consistent experience on desktops, tablets, and phones.
-   **Role Management**: Differentiate between service providers and clients for better control and customization.

## Installation

Follow these steps to set up Book2Go on your local machine:

1. **Clone the repository**:

    ```bash
    git clone https://github.com/DaniilBaida/Book2Go.git
    ```

2. **Navigate to the project directory**:

    ```bash
    cd Book2Go
    ```

3. **Install dependencies**:

    ```bash
    composer install
    npm install
    ```

4. **Set up environment variables**:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure your `.env` file**:
   Update the `.env` file with your database credentials and other necessary configurations.

6. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

7. **Start the development server**:
    ```bash
    php artisan serve
    ```

## Usage

Once installed, access the application at `http://localhost:8000`. From there, you can:

-   Register a new account or log in.
-   Explore and book services.
-   Manage your bookings and notifications.

## Contributing

We welcome contributions to improve Book2Go. Here's how you can help:

1. **Fork the repository**.
2. **Create a new branch**:
    ```bash
    git checkout -b feature-branch
    ```
3. **Commit your changes**:
    ```bash
    git commit -m 'Add new feature'
    ```
4. **Push to the branch**:
    ```bash
    git push origin feature-branch
    ```
5. **Submit a Pull Request**.

## License

Book2Go is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact

For questions, feedback, or support, please reach out via:

-   **GitHub Issues**: [Report an issue](https://github.com/DaniilBaida/Book2Go/issues)
