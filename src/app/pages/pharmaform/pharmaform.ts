import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { PharmaformService } from '../../services/pharmaform/pharmaform';

@Component({
  selector: 'app-pharmaform',
  standalone: true,
  imports: [CommonModule, FormsModule,RouterLink],
  templateUrl: './pharmaform.html',
  styleUrls: ['./pharmaform.css']
})
export class PharmaformComponent {

  Name = '';
  First_name = '';
  phone_number = '';
  gender = '';
  age: number | null = null;

  message = '';

  constructor(
    private pharmaService: PharmaformService,
    private router: Router
  ) {
    console.log("✅ PharmaformComponent chargé");
  }

  submit() {

    console.log("🔥 SUBMIT TRIGGERED");

    if (!this.Name || !this.First_name || !this.gender || !this.age) {
      this.message = 'Veuillez remplir tous les champs obligatoires';
      return;
    }

    const data = {
      Name: this.Name,
      First_name: this.First_name,
      phone_number: this.phone_number,
      gender: this.gender,
      age: this.age
    };

    console.log("📦 DATA SENT:", data);

    this.pharmaService.createPharmacien(data).subscribe({
      next: (res) => {
        console.log("✅ SUCCESS:", res);

        this.message = 'Pharmacien ajouté avec succès ✅';

        // reset form
        this.Name = '';
        this.First_name = '';
        this.phone_number = '';
        this.gender = '';
        this.age = null;

        
        this.router.navigate(['/layout/pharmacien']);
      },

      error: (err) => {
        console.log("❌ ERROR:", err);
        this.message = 'Erreur lors de l’ajout ❌';
      }
    });
  }
}