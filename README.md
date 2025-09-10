# 😊 SmilePoint

**SmilePoint** is a creative and fun web application that encourages users to smile! It allows users to capture selfies via webcam, detects smiles, and awards points based on smile intensity. The project is designed using a full stack approach with HTML, Tailwind CSS, JavaScript, PHP, and MySQL — all developed solely by **Arun Kumar Bind**.

---

## 🔥 Features

- 📸 **Capture Selfies** through browser webcam.
- 😄 **Smile Detection** using AI (future scope).
- 🏆 **Leaderboard** to view top smiling users.
- 🧑‍💻 **User Registration & Login** with session handling.
- 🖼️ **Smile Gallery** to view and manage all selfies.
- 🌐 **QR Code Integration** (for sharing or invite via selfie).
- 🌙 **Dark Mode** (optional enhancement).
- 🎨 **Smooth Animations** using GSAP, Lenis.js, and AOS.
- 💬 **AI Chatbot** (planned with Gemini API).
- ✨ **Image Enhancement** (future AI integration).

---

## 🛠️ Tech Stack

| Frontend        | Backend      | Database | Enhancements & Tools       |
| --------------- | ------------ | -------- | -------------------------- |
| HTML5,CSS3, Tailwind | PHP          | MySQL    | GSAP, Lenis.js, AOS, QR.js |
| JavaScript      | PHP Sessions |          | TensorFlow.js, Gemini API  |

---

## 📁 Project Structure

```
smilepoint/
├── assets/
│   ├── css/styles.css
│   ├── images/
│   └── js/
├── config/
│   └── database.php
├── database/
│   └── database-setup.sql
├── includes/
│   └── auth.php
├── index.php
├── login.php
├── register.php
├── profile.php
├── smile-capture.php
├── smile-gallery.php
├── leaderboard.php
├── contact.php
├── logout.php
└── README.md
```

---

## ⚙️ Getting Started

### ✅ Prerequisites

- XAMPP / Localhost setup
- PHP >= 7.x
- MySQL

### 🚀 Installation

1. Clone the repository:

 ```bash
git clone https://github.com/abx15/smilepoint.git
cd smilepoint

````

2. Import the database:
- Open phpMyAdmin
- Import `database/database-setup.sql`

3. Configure database connection:
Update `config/database.php`
```php
$host = "localhost";
$dbname = "smilepoint";
$user = "root";
$pass = "";
````

4. Start the server:

```bash
http://localhost/smilepoint/
```


## 📸 Screenshot


<img width="1871" height="928" alt="image" src="https://github.com/user-attachments/assets/1caf24c6-7836-4a75-a066-93437efbafe2" />
<img width="1786" height="891" alt="image" src="https://github.com/user-attachments/assets/9c0b2a1e-e324-4bae-a83d-2d132649d254" />
<img width="1791" height="743" alt="image" src="https://github.com/user-attachments/assets/0305795a-7127-4b24-b11e-4dda47d58c4c" />
<img width="1802" height="926" alt="image" src="https://github.com/user-attachments/assets/04da9840-51d6-4b73-ae86-9463f8cd4722" />





---

## 👤 Developer Information

- **Name**: Arun Kumar Bind
- **Role**: Full Stack Web Developer
- 📧 Email: developerarunwork@gmail.com
- 📞 Phone: +91-9129939972
- 🌐 Portfolio: [https://taupe-fox-7af636.netlify.app/](https://taupe-fox-7af636.netlify.app/)
- 🐙 GitHub: [https://github.com/abx15](https://github.com/abx15)
- 💼 LinkedIn: [https://www.linkedin.com/in/arun-kumar-a3b047353/](https://www.linkedin.com/in/arun-kumar-a3b047353/)
- 📷 Instagram: [https://www.instagram.com/\_\_\_\_abx15](https://www.instagram.com/____abx15?igsh=cXNmb3B5aGt5NnBu)

- 👍 Facebook: [https://www.facebook.com/share/16QU53HraS](https://www.facebook.com/share/16QU53HraS)

---

## 🤖 Future Enhancements

- [ ] AI-powered smile scoring (TensorFlow.js or Face++ API)
- [ ] Chatbot integration using Gemini API
- [ ] Image enhancement using AI libraries
- [ ] QR Code generator for selfie sharing and registration

---

## 📜 License

This project is built and maintained by **Arun Kumar Bind** for learning and portfolio purposes. Feel free to use or modify with proper credit.

---

**Made with 💖 to spread happiness — one smile at a time.**
