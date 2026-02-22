# Fælled United — Website Introduction

This document gives a quick overview of what the club website does — both what members and parents can access, and what the admin panel offers for the people running the club. It's written for a non-technical audience.

---

## The website

The site gives the club a proper home online. It's available in both Danish and English, and it works on phones, tablets, and desktops.

Here's the address for the test version: **https://faelledunited-sitaiowr.on-forge.com**

---

## What visitors can do

**Read club news**
The homepage shows the latest updates from the club. News posts can include photos and are managed by admins.

**Browse departments**
Each department — football, handball, etc. — has its own page with a description, age groups, and contact information.

**Register a child**
Parents can register their child directly on the website. The form collects the child's name, date of birth, department preference, and parent contact details. A confirmation email is sent after submission. (Note: the formal DBU registration still goes through the club's normal DBU process — this is the initial sign-up, not a replacement for that.)

**Contact the club**
There's a contact form for general questions. Messages go straight to the admin panel where they can be picked up and replied to.

**Sign up for club news by email**
Visitors can join the mailing list to receive newsletters and updates. Every email includes an unsubscribe link.

**Read the statutes**
The club's vedtægter (statutes) are published on the site and kept up to date by admins.

**Club shop (coming soon)**
A shop page is live, announcing the upcoming partnership with Sport24 for club kit orders.

---

## The admin panel

The admin panel is at `/admin`. Each admin logs in with their email and password. The interface is available in both Danish and English — each user sets their own preference.

### Dashboard

The first thing you see when you log in. It shows:
- How many contact inquiries are waiting for a reply
- New registrations in the last 30 days
- Total mailing list subscribers

### Contact inquiries

Every message sent through the contact form appears here. Admins can assign an inquiry to a specific team member, reply directly from the panel (the reply goes to the visitor's email address), and mark it as replied. The status updates automatically when a reply is sent.

### Registrations

All player registrations in one place — child's details, parent contact info, selected department, and submission date.

### Newsletter

Compose and send email newsletters to everyone on the mailing list, or to a specific group of subscribers. You can save a draft and preview it before sending anything. Sent newsletters are archived with a count of how many were delivered.

### News posts

Create and manage news updates. Posts support formatted text and images, and they appear on the club homepage.

### Departments

Update the list of departments — names, descriptions, hero images, and associated age groups.

### Board members

Manage board profiles: name, title, and photo. These appear on the About page.

### Mailing list subscribers

View and manage the list of people who have signed up for email updates.

### Statutes and privacy policy

Both are editable directly in the admin panel. Both support Danish and English versions.

### User management

Create and manage admin accounts — name, email, password, and preferred language. Admins cannot delete their own account.

---

## A note on email

The site sends confirmation emails for contact form submissions, mailing list sign-ups, and player registrations. These require an email service to be configured on the server (Resend/Mailgun). Once that's in place, everything is automatic.

---

*Built by SC CodeCraft for Fælled United. Questions? Contact sam@sc-codecraft.com.*
