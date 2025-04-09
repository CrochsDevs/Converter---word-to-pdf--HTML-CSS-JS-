# 📄 Word to PDF Converter

A simple web-based tool that allows users to convert Word documents (`.doc`, `.docx`) into PDF format using HTML, CSS, JavaScript, PHP, and LibreOffice. This project runs locally via a XAMPP server setup.

---

## ✅ Features

- Upload Word files (.doc/.docx)
- Convert to PDF instantly
- Clean and responsive UI
- No need for third-party online services
- Powered by LibreOffice and PHP

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

### 1. Install Required Software

#### 🔹 LibreOffice (for conversion engine)
- Download from [https://www.libreoffice.org/](https://www.libreoffice.org/)
- Run the installer and choose **"Typical"** installation
- Take note of the installation path (usually `C:\Program Files\LibreOffice`)

#### 🔹 XAMPP (for PHP and Apache server)
- Download from [https://www.apachefriends.org/](https://www.apachefriends.org/)
- Install using default options
- Open **XAMPP Control Panel**
  - Start **Apache**
  - (Optional) Start **MySQL** if needed later

---

## 📂 How to Use

1. Place the project folder inside the `htdocs` directory (usually located at `C:\xampp\htdocs`)
2. Open your browser and go to:  
   `http://localhost/your-folder-name/`
3. Upload a `.doc` or `.docx` file
4. Click the **Convert to PDF** button
5. The converted PDF will be downloaded or displayed depending on your browser settings

---

## ⚠️ Notes

- LibreOffice must be installed for the conversion to work.
- On Windows, PHP will execute a command to use LibreOffice in headless mode.
- Make sure Apache is running in XAMPP before using the converter.

---

## 📌 License

This project is open-source and free to use under the MIT License.

---

## 🙌 Acknowledgements

- [LibreOffice](https://www.libreoffice.org/)
- [XAMPP](https://www.apachefriends.org/)

---

**Created with ❤️ by [CROCHSDEVS](https://github.com/CROCHSDEVS)**
