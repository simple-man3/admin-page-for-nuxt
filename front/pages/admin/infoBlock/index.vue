<script>
export default {
  auth:true,
  middleware({redirect})
  {
    return redirect('301','/admin/infoBlock/page/1');
  }
}
</script>

<style scoped>
.wrapTitleId,
.wrapCheckBox,
.wrapSingleBtn{
  width: 64px;
}

.wrapInfoBlocks a{
  text-decoration: none;
}

.wrapInfoBlocks table{
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.wrapInfoBlocks table input[type='checkbox']{
  cursor: pointer;
}

.wrapInfoBlocks table tr:last-child td{
  border: none;
}

.wrapInfoBlocks table td{
  padding: 15px;
  border-bottom: 1px solid #cbcbcb
}

.wrapInfoBlocks table .linkInfoBlock{
  text-decoration: none;
  color: #3490dc;
  transition: .3s;
}

.wrapInfoBlocks table .linkInfoBlock:hover{
  color: #1d68a7;
}

.wrapInfoBlocks .wrapTopPanel{
  display: flex;
  flex-flow: wrap;
}

.wrapInfoBlocks .wrapTopPanel .wrapLeft{
  width: 50%;
}

.wrapInfoBlocks .wrapTopPanel .wrapRight{
  width: 50%;
  display: flex;
  justify-content: flex-end;
}

.btnAdd{
  width: 200px;
  background-color: #007bff;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 38px;
  color: white;
}
</style>
