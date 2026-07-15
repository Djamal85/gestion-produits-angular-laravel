import { Component, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-assurance',
  imports: [FormsModule],
  templateUrl: './assurance.html',
  styleUrl: './assurance.css',
})
export class Assurance {
  nom = signal('DIOP');
  prenom = signal('Abdou');
  age = signal(20);
  verif = signal(true);

  tabPerso = signal([
    { id: 1, titre: 'Premier article'},
    { id: 2, titre: 'Deuxieme article' },
    { id: 3, titre: 'Trois article' },
    { id: 4, titre: 'Quatre article' },
  ]);

  constructor() {}

  print() {
    alert(this.nom + ' ' + this.prenom + ' ' + this.age);
  }
}
