# 📦 Inflow – Social Analytics Dashboard for Influencers

**Inflow** is a Laravel-based web application designed to help social media influencers monitor and analyze engagement across their accounts. The platform provides a unified dashboard where users can track views, interactions, and engagement rates from multiple social platforms.

---

## 🎯 Purpose

Influencers often struggle to keep track of their performance across different networks. Inflow solves this by offering a centralized system that connects to major platforms and visualizes key metrics in one place.

---

## 🚀 Features

- **Multi-Platform Login**: Connect and authenticate with Facebook, Instagram, Snapchat, Twitter.  
- **Engagement Tracking**: View total impressions, likes, comments, shares, and follower growth.  
- **Cross-Platform Dashboard**: Compare performance across accounts in a single view.  
- **Interaction Rate Calculation**: Automatically compute engagement rates based on platform data.  
- **Secure Authentication**: OAuth-based login for each platform.  
- **Responsive Design**: Optimized for mobile and desktop use.

---

## 🛠 Tech Stack

- Laravel 7.29  
- PHP 7.4+  
- MySQL  
- OAuth APIs (Facebook, Instagram, Snapchat, Twitter)  
- Chart.js  
- Bootstrap 4

---


## 📦 Installation

```bash
git clone https://github.com/fidaaalmassri/Inflow.git
cd Inflow
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
