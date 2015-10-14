<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" />
<xsl:template match="/">
	<div>
		<h3 id="lb">Shopping Catalog</h3>
		<table class="tableCat">
		<tr>
			<th>Item Number</th>
			<th>Name</th>
			<th>Description</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Add</th>
		</tr>

			<xsl:for-each select="/items/item[quantity &gt; 0]">
				<tr>
					<xsl:variable name="id" select="id"> </xsl:variable>
					
					<td><xsl:value-of select="id" /></td>
					<td><xsl:value-of select="name" /></td>
					<td><xsl:value-of select="description" /></td>
					<td><xsl:value-of select="price" /></td>
					<td><xsl:value-of select="quantity" /></td>
					<td>
						<input type="button" value="Add one to cart" onclick="AddRemoveItem('Add','{$id}');"/>
					</td>
				</tr>				
			</xsl:for-each>
		</table>
	</div>	
</xsl:template>
</xsl:stylesheet>
