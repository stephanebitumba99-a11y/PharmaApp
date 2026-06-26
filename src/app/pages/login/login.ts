import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { LoginService } from '../../services/login/login';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.html',
  styleUrls: ['./login.css']
})
export class LoginComponent {

  email = '';
  password = '';
  message = '';

  constructor(
    private loginService: LoginService,
    private router: Router
  ) {}

  login() {

    if (!this.email || !this.password) {
      this.message = "Email et mot de passe requis";
      return;
    }

    const data = {
      email: this.email,
      password: this.password
    };

    this.loginService.login(data).subscribe({
      next: (res: any) => {

        localStorage.setItem('token', res.token);

        this.router.navigate(['/layout/dashbord']); 
      },

      error: (err: any) => {
        this.message = err.error.message || "Identifiants incorrects";
      }
    });
  }
}