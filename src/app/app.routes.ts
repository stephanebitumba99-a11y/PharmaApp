import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login';
import { Dashbord } from './pages/dashbord/dashbord';
import { Accueil } from './pages/accueil/accueil';
import { ProduitsComponent } from './pages/produit/produit';
import { PharmacienComponent } from '../../src/app/pages/pharmacien/pharmacien';
import { PharmaformComponent } from './pages/pharmaform/pharmaform';
import { LayoutComponent } from './pages/layout/layout';
import { ProduitFormComponent } from '../../src/app/pages/produitform/produitform';



export const routes: Routes = [
  {
    path: '',
    component: Accueil
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path:'layout',
    component: LayoutComponent,

    children: [
        {
    path: 'dashbord',
     component: Dashbord
   },
   {
    path: 'produit',
    component: ProduitsComponent
   },
   {
    path: 'pharmacien',
    component: PharmacienComponent
   },
    ]
  },
   {
    path: 'pharmaform',
    component: PharmaformComponent
   },
   {
    path: 'produitform',
    component: ProduitFormComponent
   },
]
  

  