<style>
/* ========== FOOTER PREMIUM ========== */
.footer {
    background: linear-gradient(135deg, #003366 0%, #0a2a4a 100%);
    color: white;
    padding: 50px 0 20px;
    margin-top: 0;
    position: relative;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
}

.footer-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
    position: relative;
    display: inline-block;
    padding-bottom: 8px;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: #c6a43b;
    border-radius: 2px;
    transition: width 0.3s ease;
}

.footer-col:hover .footer-title::after {
    width: 60px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.footer-links a i {
    font-size: 0.7rem;
    opacity: 0;
    transition: all 0.3s ease;
}

.footer-links a:hover {
    color: #c6a43b;
    transform: translateX(5px);
}

.footer-links a:hover i {
    opacity: 1;
    transform: translateX(3px);
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
}

.footer-contact li:hover {
    transform: translateX(5px);
    color: #c6a43b;
}

.footer-contact li i {
    color: #c6a43b;
    width: 20px;
}

.social-icons {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    color: white;
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid rgba(198, 164, 59, 0.2);
}

.social-icon:hover {
    background: linear-gradient(135deg, #c6a43b, #a8892e);
    color: #003366;
    transform: translateY(-5px) rotate(360deg);
    border-color: transparent;
}

.copyright {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 20px;
    margin-top: 35px;
    text-align: center;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

/* Footer Responsive */
@media (min-width: 992px) {
    .footer .row {
        display: flex;
        flex-wrap: wrap;
    }
}

@media (max-width: 991px) and (min-width: 577px) {
    .footer .row {
        display: flex;
        flex-wrap: wrap;
    }
    .footer .row > div:nth-child(1) {
        width: 100%;
        margin-bottom: 30px;
    }
    .footer .row > div:nth-child(2),
    .footer .row > div:nth-child(3),
    .footer .row > div:nth-child(4) {
        width: 33.333%;
    }
}

@media (max-width: 576px) {
    .footer {
        padding: 40px 0 20px;
    }
    .footer .row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
    .footer .row > div:nth-child(1) {
        grid-column: span 2;
    }
    .footer .row > div:nth-child(4) {
        grid-column: span 2;
    }
    .footer-title {
        font-size: 0.95rem;
    }
    .footer-links a, .footer-contact li {
        font-size: 0.75rem;
    }
    .social-icon {
        width: 34px;
        height: 34px;
    }
    .copyright {
        font-size: 0.65rem;
    }
}

@media (max-width: 380px) {
    .footer .row {
        gap: 20px;
    }
    .footer-title {
        font-size: 0.85rem;
    }
    .social-icon {
        width: 30px;
        height: 30px;
        font-size: 0.7rem;
    }
}
</style>
