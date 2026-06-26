import { Component, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashbordService } from '../../services/dashbord/dashbord';

@Component({
  selector: 'app-dashbord',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './dashbord.html',
  styleUrls: ['./dashbord.css']
})
export class Dashbord implements OnInit {

  // ✅ SIGNALS
  stats = signal<any>(null);
  stockFaibleList = signal<any[]>([]);
  loading = signal<boolean>(false);
  todayDate = new Date().toLocaleDateString('fr-FR', { 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric' 
  });

  constructor(private service: DashbordService) {}

  ngOnInit(): void {
    this.loadStats();
  }

  loadStats() {
    this.loading.set(true);

    this.service.getStats().subscribe({
      next: (res: any) => {
        this.stats.set(res);
        this.stockFaibleList.set(res.stock_faible_list ?? []);
        this.loading.set(false);
      },
      error: (err) => {
        console.error('Erreur lors du chargement des stats:', err);
        this.loading.set(false);
        // Option: afficher un toast d'erreur
      }
    });
  }

  // Formate les nombres avec séparateur de milliers
  formatNumber(value: number): string {
    if (!value) return '0';
    return new Intl.NumberFormat('fr-FR').format(value);
  }
}