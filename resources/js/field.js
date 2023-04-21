import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-file-upload', IndexField)
  app.component('detail-file-upload', DetailField)
  app.component('form-file-upload', FormField)
})
