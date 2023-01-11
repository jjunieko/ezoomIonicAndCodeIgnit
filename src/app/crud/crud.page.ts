import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { LoadingController } from '@ionic/angular';
import { FormGroup, FormBuilder } from "@angular/forms";

@Component({
  selector: 'app-crud',
  templateUrl: './crud.page.html',
  styleUrls: ['./crud.page.scss'],
})
export class CrudPage implements OnInit {

  @Input() id: number;

  items: any[];
  apiUrl = 'http://localhost:8080/produtos'
  public carregar: any;
  public form: FormGroup;

  constructor(
    private authService: AuthService,
		private router: Router,
    private http: HttpClient,
    public loading: LoadingController,
    public formBuilder: FormBuilder,
  ) {
    this.getItems();
    this.form = formBuilder.group({
      nome: [""],
      valor: [""],
    });
   }

  ngOnInit() {
  
  }


  async logout() {
		await this.authService.logout();
		this.router.navigateByUrl('/', { replaceUrl: true });
	}

  navigate(){
		this.router.navigate(['/home'])
	  }


    // public async submitForm(): Promise<void> {
    //   await this.showCarregar();
    //   //console.log(this.form.value);
    //   this.comida.salvarComida(this.form.value, this.id);
    //   await this.fecharCarregando();
    // }


   async getItems() {
    await this.showCarregar();
      await this.http.get(this.apiUrl).subscribe((data :any) => {
        this.items = data;
      }, err => {
        console.log(err);
      });
      await this.fecharCarregando();

    }
    onSubmit() {

      // return addItem(name: string, valor: string) {
        this.http.post(this.apiUrl + '/create/', {}).subscribe(res => {
          this.getItems();
        }, err => {
          console.log(err);
        });
      // }
    }
  
    updateItem(itemId: string, name: string) {
      this.http.put(this.apiUrl + 'upload/' + itemId, { name }).subscribe(res => {
        this.getItems();
      }, err => {
        console.log(err);
      });
    }
  
    deleteItem(itemId: string) {
      this.http.delete(this.apiUrl + '/' + itemId).subscribe(res => {
        this.getItems();
      }, err => {
        console.log(err);
      });
    }


    // buscar dados
    search(event): void {
      let valorProcurado = event.target.value;
  
      if (!valorProcurado) {
        this.getItems();
        return;
      }
      this.items = this.items.filter((dado) => {
        return dado.nome
          .toLocaleLowerCase()
          .includes(valorProcurado.toLowerCase());
      });
    }
  
    clear(): void {
      this.getItems();
    }


    // loading 
    async showCarregar(): Promise<void> {
      this.carregar = await this.loading.create({
        duration: 2000,
        message: "Aguarde...",
      });
      await this.carregar.present();
    }
    async fecharCarregando(): Promise<void> {
      await this.carregar.dismiss();
    }
  
  }

